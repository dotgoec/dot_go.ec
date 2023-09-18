Bun.serve({
    port: process.env.PORT,
    hostname: process.env.IP,
    fetch(req) {
      return new Response(`
      DOT_GO
      page in construction`);
    },
  });