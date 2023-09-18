Bun.serve({
    port: process.env.PORT,
    hostname: process.env.IP,
    fetch(req) {
      const url = new URL(req.url);
      const isindex = url.pathname.search(".") >= 0 ? "" : "index.html";
      filepath = "public" + url.pathname + isindex;
      console.log(filepath);
      const file = Bun.file(filepath);
      if (file.size != 0) {
        return new Response(pathfile);
      } else {
        return new Response("404!");
      }
    },
  });