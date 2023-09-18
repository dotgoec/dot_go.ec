Bun.serve({
    port: process.env.PORT,
    hostname: process.env.IP,
    fetch(req) {
      const url = new URL(req.url);
      console.log("public" + url.pathname + (url.pathname.search(".") >= 0 ? "" : "index.html"));
      const pathfile = Bun.file("public" + url.pathname + (url.pathname.search(".") >= 0 ? "" : "index.html"));
      if (pathfile.size != 0) {
        return new Response(pathfile);
      } else {
        return new Response("404!");
      }
    },
  });