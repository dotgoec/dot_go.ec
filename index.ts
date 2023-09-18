Bun.serve({
    port: process.env.PORT,
    hostname: process.env.IP,
    fetch(req) {
      return new Response(`
        <html>
        <head></head>
        <body>Bun!<br>🤔</body>
        </hhtml>`);
    },
  });