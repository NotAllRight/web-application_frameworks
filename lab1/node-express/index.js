const express = require('express');
const app = express();
const port = 3000;

app.get('/node-express', (req, res) => {
  res.send('Hello, Express.js!');
});

app.listen(port, () => {
  console.log(`Server is running at http://localhost:${port}`);
});

