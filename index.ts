let debugging = false;
const TelegramBot = require('node-telegram-bot-api');
const pointsPath = "public/narcolombia/points.csv";
let points = Bun.file(pointsPath);
// const pwriter = points.writer();
// pwriter.unref();
const addPoint = async (p) => {
  // pwriter.ref();
  // pwriter.write(p.toString());
  // pwriter.flush(); // write buffer to disk
  // pwriter.unref();
  Bun.write(pointsPath,p);
};
const wss = Bun.serve({
    port: process.env.PORT,
    hostname: process.env.IP,
    fetch(req, server) {
      if (debugging) console.log("REQUEST: ",req);
      if (debugging) console.log("SERVER: ",server);
      // upgrade the request to a WebSocket
      let cookies = new Headers();
      cookies.append("Set-Cookie",`sessionID=${Math.floor(Math.random() * Date.now()).toString(16)}`);
      cookies.append("Set-Cookie",`mapTilesKey=${process.env.MAPTILES_KEY}`);
      cookies.append("Set-Cookie",`jawgKey=${process.env.JAWG_KEY}`);
      cookies.append("Set-Cookie",`stadiaKey=${process.env.STADIA_KEY}`);
      cookies.append("Set-Cookie",`mapTilerKey=${process.env.MAPTILER_KEY}`);
      if (server.upgrade(req, {
        headers: cookies,
      })) {
        return; // do not return a Response
      }
      return new Response("🤨", { status: 500 });
    }, // upgrade logic
    websocket: {
      // handler called when a message is received
      async message(ws, message) {
        if (debugging) console.log("MESSAGE\n", ws, message);
        let msg, pmsg;
        try {
          msg = JSON.parse(message)
        } catch(err) {
          console.warn(err);
          msg = message;
        }
        switch ( msg[0] ) {
          case "addPoint":
            addPoint(await points.text() + msg[1]);
            pmsg = await points.text();
            ws.send(JSON.stringify( ["points", pmsg.split('\n')] ) );
            ws.publish("points", JSON.stringify( ["points", pmsg.split('\n')] ) );
            break;
          case "debug":
            debugging = !debugging;
            break;
          default:
            if (debugging) console.log(msg);
            break;
        }
      },
      async open(ws) {
        if (debugging) console.log("OPEN\n", ws);
        console.log("SUBSCRIBED: ",ws.subscribe("points"));
        const pmsg = await points.text();
        console.log("SENT: ",ws.send(JSON.stringify( ["points", pmsg.split('\n')] ) ));
        console.log("PUBLISHED: ", ws.publish("points", JSON.stringify( ["points", pmsg.split('\n')] ) ));
      }, // a socket is opened
      async close(ws, code, message) {
        if (debugging) console.log("CLOSE\n", ws, code, message);
        console.log("UNSUBSCRIBED: ",ws.unsubscribe("points"));
        const pmsg = await points.text();
        console.log("PUBLISHED: ", ws.publish("points", JSON.stringify( ["points", pmsg.split('\n')] ) ));
      }, // a socket is closed
      drain(ws) {
        if (debugging) console.log("DRAIN\n", ws);
      }, // the socket is ready to receive more data
    },
  });
console.log("Started!");

// const ws = Bun.serve({
    // port: process.env.PORT,
    // hostname: process.env.IP,
    // fetch(req) {
      // const url = new URL(req.url);
      // const isindex = url.pathname.search(/\./) >= 0 ? "" : (url.pathname.search(/\/$/) >= 0 ? "" : "/") + "index.php";
      // const filepath = "public" + url.pathname + isindex;
      // const file = Bun.file(filepath);
      // if (file.size != 0) {
        // return new Response(file);
      // } else {
        // throw new Error("404: File not found!");
      // }
    // },
    // error(error) {
      // return new Response(`<pre>${error}\n${error.stack}</pre>`, {
        // headers: {
          // "Content-Type": "text/html",
        // },
      // });
    // },
  // });
  
const tBot = new TelegramBot(process.env.TELEGRAM_BOT_TOKEN, {polling: true});
console.log(tBot);
let narColombiaVoiceNote = false;
tBot.on('message', (msg) => {
  const chat = msg.chat;
  console.log("CHAT:\n",chat);
  if ( msg.text ) {
    console.log("MESSAGE: ",msg.text);
      switch ( msg.text ) {
        case '/start':
          tBot.sendMessage(chat.id, `Hola ${chat.username}! Para enviar tu relato de experiencia de robo en Guayaquil, envia una nota de voz o un audio al respecto.`);
          narColombiaVoiceNote = true;
          break;
        default:
          tBot.sendMessage(chat.id,"Por ahora solo recibo notas de voz para el registro de nuestra muestra:\n ```En cualquier parte de Guayaquil roban? Cartografias de robos urbanos en Guayaquil.```\nEnvia una nota de voz contando tu experiencia de robo en Guayaquil.");
          break;
      }
  }
  if ( msg.voice ) {
    console.log("VOICE NOTE:\n",msg.voice);
    if ( narColombiaVoiceNote ) {
      tBot.sendVoice(process.env.NARCOLOMBIA_TELEGRAM_CHANNEL_ID, msg.voice.file_id);
      tBot.sendMessage(chat.id,"Gracias por contar tu experiencia!\nEl audio ha sido recibido correctamente y anadido al registro en [nuestro canal publico de la muestra](https://t.me/narcolombia_gye2023).");
    }
  }
});