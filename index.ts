let debugging = false;
const TelegramBot = require('node-telegram-bot-api');
const pointsPath = { narcolombia: "public/narcolombia/points.csv", bravasomosec: "public/bravasomosec/points.csv" };
const voicenotesPath = { narcolombia: "public/narcolombia/voicenotes.csv", bravasomosec: "public/bravasomosec/voicenotes.csv" };
let points = { narcolombia: Bun.file(pointsPath.narcolombia), bravasomosec: Bun.file(pointsPath.bravasomosec) };
let voicenotes = { narcolombia: Bun.file(voicenotesPath.narcolombia), bravasomosec: Bun.file(voicenotesPath.bravasomosec) };

const addText = async (path, text) => {
  console.log("WRITTEN: ",Bun.write(path, text));
};

const wss = Bun.serve({
    port: process.env.PORT,
    hostname: process.env.IP,
    fetch(req, server) {
      if (debugging) console.log("REQUEST: ",req);
      if (debugging) console.log("SERVER: ",server);
      // upgrade the request to a WebSocket
      let cookies = new Headers();
      cookies.append("Set-Cookie",`Secure`);
      cookies.append("Set-Cookie",`SameSite=none`);
      cookies.append("Set-Cookie",`sessionID=${Math.floor(Math.random() * Date.now()).toString(16)}`);
      cookies.append("Set-Cookie",`mapTilesKey=${process.env.MAPTILES_KEY}`);
      cookies.append("Set-Cookie",`jawgKey=${process.env.JAWG_KEY}`);
      cookies.append("Set-Cookie",`stadiaKey=${process.env.STADIA_KEY}`);
      cookies.append("Set-Cookie",`mapTilerKey=${process.env.MAPTILER_KEY}`);
      cookies.append("Set-Cookie",`GeocoderKEY=${process.env.GEOCODER_KEY}`);
      if (server.upgrade(req, {
        headers: cookies,
      })) {
        return; // do not return a Response
      }
      return new Response("🤨🫡", { status: 500 });
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
						switch ( msg[1] ) {
							case "narcolombia":
								addText(pointsPath.narcolombia, await points.narcolombia.text() + msg[2]);
								pmsg = await points.narcolombia.text();
								jsonnarcolombia = JSON.stringify( ["pnarcolombia", pmsg.split('\n')] );
								ws.send(jsonnarcolombia);
								ws.publish("pnarcolombia", jsonnarcolombia);
							break;
							case "bravasomosec":
								addText(pointsPath.bravasomosec, await points.bravasomosec.text() + msg[2]);
								pmsg = await points.bravasomosec.text();
								jsonbravasomosec = JSON.stringify( ["pbravasomosec", pmsg.split('\n')] );
								ws.send(jsonbravasomosec);
								ws.publish("pbravasomosec", jsonbravasomosec);
							break;
						}
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
				// narcolombia
        const pmsgnarcolombia = await points.narcolombia.text();
        console.log("SENT: ",ws.send(JSON.stringify( ["pnarcolombia", pmsgnarcolombia.split('\n')] ) ));
        console.log("PUBLISHED: ", ws.publish("pnarcolombia", JSON.stringify( ["pnarcolombia", pmsgnarcolombia.split('\n')] ) ));
				// bravasomosec
        const pmsgbravasomosec = await points.bravasomosec.text();
        console.log("SENT: ",ws.send(JSON.stringify( ["pbravasomosec", pmsgbravasomosec.split('\n')] ) ));
        console.log("PUBLISHED: ", ws.publish("pbravasomosec", JSON.stringify( ["pbravasomosec", pmsgbravasomosec.split('\n')] ) ));
      }, // a socket is opened
      async close(ws, code, message) {
        if (debugging) console.log("CLOSE\n", ws, code, message);
        console.log("UNSUBSCRIBED: ",ws.unsubscribe("points"));
				// narcolombia
        const pmsgnarcolombia = await points.narcolombia.text();
        console.log("PUBLISHED: ", ws.publish("pnarcolombia", JSON.stringify( ["pnarcolombia", pmsgnarcolombia.split('\n')] ) ));
				// bravasomosec
        const pmsgbravasomosec = await points.bravasomosec.text();
        console.log("PUBLISHED: ", ws.publish("pbravasomosec", JSON.stringify( ["pbravasomosec", pmsgbravasomosec.split('\n')] ) ));
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
let narColombiaVoiceNote = {};
let bravasomosecVoiceNote = {};
tBot.on('message', async (msg) => {
  const chat = msg.chat;
  const menu = `Menu:\n
		/start\n\tReinicia la interacción con el bot.\n
		/narcolombia\n\tEnvía un mensaje de voz contando tu experiencia de robo en Guayaquil.\n
		/bravasomosec\n\tEnvía un mensaje de voz contando tu celebración de un partido de fútbol en Ecuador.`;
  if (debugging) console.log("CHAT:\n",chat);
  if ( narColombiaVoiceNote[msg.from.id] === undefined ) narColombiaVoiceNote[msg.from.id] = false;
	const stringifymsg = JSON.stringify(msg, null, "\t").replace(/\\n/g, "\\n\\n").replace(/\\'/g, "\\'").replace(/\\"/g, '\\"').replace(/\\&/g, "\\&").replace(/\\r/g, "\\r").replace(/\\t/g, "\\t").replace(/\\b/g, "\\b").replace(/\\f/g, "\\f");
	if (debugging) console.log("MESSAGE: ", stringifymsg);
	if (debugging) tBot.sendMessage(process.env.DEBUG_GROUPID, "```json\n" + stringifymsg + "\n```",{ parse_mode: "Markdown", disable_notification: true, protect_content: true });
	if (debugging) console.log("FROM: ", msg.from);
	const invalidMsg = "Comando o mensaje incorrecto\nsi necesitas ayuda revisa el /menu para más informaci��n.";
  if ( msg.text ) {
    if (debugging) console.log("MESSAGE TEXT: ",msg.text);
      switch ( msg.text ) {
        case '/start':
          narColombiaVoiceNote[msg.from.id] = false;
          bravasomosecVoiceNote[msg.from.id] = false;
          tBot.sendMessage(chat.id, `Hola${ chat.username ? " " + chat.username : "" }!\nPara empezar selecciona un comando dándole click del ${menu}.`);
          break;
				case '/menu':
					tBot.sendMessage(chat.id, menu);
					break;
				case '/narcolombia':
          bravasomosecVoiceNote[msg.from.id] = false;
					narColombiaVoiceNote[msg.from.id] = true;
					tBot.sendMessage(chat.id, `Listo, envía tu mensaje voz a continuación. Una vez recibido será enviado al canal de telegram público de NarColombia.\nSi quieres cancelar esta opción responde con /vcancel.`);
					break;
				case '/bravasomosec':
          narColombiaVoiceNote[msg.from.id] = false;
					bravasomosecVoiceNote[msg.from.id] = true;
					tBot.sendMessage(chat.id, `Listo, envía tu mensaje voz a continuación. Una vez recibido será enviado al canal de telegram público de Brava Somos, Ecuador.\nSi quieres cancelar esta opción responde con /vcancel.`);
					break;
				case '/vcancel':
          narColombiaVoiceNote[msg.from.id] = false;
          bravasomosecVoiceNote[msg.from.id] = false;
					tBot.sendMessage(chat.id, `Recepción de mensaje de voz cancelada o reiniciada. ${menu}`);
					break;
				case '/debug':
          tBot.sendMessage(chat.id,invalidMsg);
					debugging = !debugging;
					tBot.sendMessage(process.env.DEBUG_GROUPID, `Debugging set to ${debugging}`);
					break;
        default:
          tBot.sendMessage(chat.id,invalidMsg);
          break;
      }
  }
  if ( msg.voice ) {
    if (debugging) console.log("VOICE NOTE:\n",msg.voice);
    if ( narColombiaVoiceNote[msg.from.id] ) {
      tBot.sendVoice(process.env.NARCOLOMBIA_TELEGRAM_CHANNEL_ID, msg.voice.file_id);
      tBot.sendMessage(chat.id,"Gracias por compartir tu experiencia!\nEl audio ha sido recibido correctamente y añadido al registro en nuestro canal publico de la muestra:\n https://t.me/narcolombia_gye2023.");
      addText(voicenotesPath.narcolombia, await voicenotes.narcolombia.text() + msg.from.id + ',' + msg.voice.file_id + '\n');
			narColombiaVoiceNote[msg.from.id] = false;
    } else if ( bravasomosecVoiceNote[msg.from.id] ) {
      tBot.sendVoice(process.env.BRAVASOMOSEC_TELEGRAM_CHANNEL_ID, msg.voice.file_id);
      tBot.sendMessage(chat.id,"Gracias por compartir tu experiencia!\nEl audio ha sido recibido correctamente y añadido al registro en nuestro canal publico de la muestra:\n https://t.me/bravasomosec.");
      addText(voicenotesPath.bravasomosec, await voicenotes.bravasomosec.text() + msg.from.id + ',' + msg.voice.file_id + '\n');
			bravasomosecVoiceNote[msg.from.id] = false;
    } else {
			tBot.sendMessage(chat.id,"No has seleccionado la opción correcta antes de enviar el mensaje de voz, por favor elige la opción correcta del /menu de comandos y reenvía el mensaje de voz o grábalo nuevamente.");
		}
  }
});
