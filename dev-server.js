const { createReadStream, promises: fs } = require("node:fs");
const http = require("node:http");
const path = require("node:path");

const publicDirectory = path.resolve(__dirname, "node_modules", "src");
const host = process.env.HOST || "127.0.0.1";
const port = Number(process.env.PORT || 4173);
const contentTypes = {
  ".css": "text/css; charset=utf-8",
  ".html": "text/html; charset=utf-8",
  ".jpg": "image/jpeg",
  ".jpeg": "image/jpeg",
  ".js": "text/javascript; charset=utf-8",
};

const server = http.createServer(async (request, response) => {
  if (request.method !== "GET" && request.method !== "HEAD") {
    response.writeHead(405, { Allow: "GET, HEAD" });
    response.end("Method Not Allowed");
    return;
  }

  let pathname;
  try {
    pathname = decodeURIComponent(new URL(request.url, `http://${host}`).pathname);
  } catch {
    response.writeHead(400);
    response.end("Bad Request");
    return;
  }

  const requestedPath = pathname === "/" ? "/index.html" : pathname;
  const filePath = path.resolve(publicDirectory, `.${requestedPath}`);
  const relativePath = path.relative(publicDirectory, filePath);

  if (relativePath.startsWith("..") || path.isAbsolute(relativePath)) {
    response.writeHead(403);
    response.end("Forbidden");
    return;
  }

  try {
    const file = await fs.stat(filePath);
    if (!file.isFile()) {
      response.writeHead(404);
      response.end("Not Found");
      return;
    }

    response.writeHead(200, {
      "Content-Length": file.size,
      "Content-Type": contentTypes[path.extname(filePath).toLowerCase()] || "application/octet-stream",
    });

    if (request.method === "HEAD") {
      response.end();
      return;
    }

    const stream = createReadStream(filePath);
    stream.on("error", (error) => {
      console.error(`Failed to read ${filePath}:`, error);
      if (!response.headersSent) {
        response.writeHead(500);
      }
      response.end("Internal Server Error");
    });
    stream.pipe(response);
  } catch (error) {
    if (error.code === "ENOENT" || error.code === "ENOTDIR") {
      response.writeHead(404);
      response.end("Not Found");
      return;
    }

    console.error(`Failed to serve ${filePath}:`, error);
    response.writeHead(500);
    response.end("Internal Server Error");
  }
});

server.listen(port, host, () => {
  console.log(`FlipPlay dev server running at http://${host}:${port}`);
});

server.on("error", (error) => {
  console.error("Development server failed to start:", error);
  process.exitCode = 1;
});
