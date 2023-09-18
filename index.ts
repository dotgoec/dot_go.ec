Bun.serve({
    port: process.env.PORT,
    hostname: process.env.IP,
    fetch(req) {
      const url = new URL(req.url);
      const isindex = url.pathname.search(".") < 0 ? "" : "index.html";
      const filepath = "public" + url.pathname + isindex;
      console.log(url.pathname,filepath);
      const file = Bun.file(filepath);
      if (file.size != 0) {
        return new Response(file);
      } else {
        throw new Error("404!");
      }
    },
  });