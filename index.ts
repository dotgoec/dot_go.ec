Bun.serve({
    port: process.env.PORT,
    hostname: process.env.IP,
    fetch(req) {
      const url = new URL(req.url);
      const pathfile = Bun.file("public" + url.pathname);
      if (pathfile.size != 0) return new Response(pathfile);
      return new Response("404!");
    },
  });