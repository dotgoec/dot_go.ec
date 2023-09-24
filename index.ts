let debugging = false;
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
      if (server.upgrade(req, {
        headers: {
          "Set-Cookie": `SessionId=${Math.floor(Math.random() * Date.now()).toString(16)}`,
        },
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