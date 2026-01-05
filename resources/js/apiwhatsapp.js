const { Client, LocalAuth } = require("whatsapp-web.js");
const qrcode = require("qrcode-terminal");
const axios = require("axios");

// Laravel API URL
const API = "http://inventory.pramita.co.id:8000/api/v2/getway/whatsapp/status";

const client = new Client({
    authStrategy: new LocalAuth({
        dataPath: "dataClient",
    }),
});

client.on("qr", (qr) => {
    qrcode.generate(qr, { small: true });
});

client.on("ready", () => {
    console.log("WhatsApp Client Ready!");
    startLoop();
});

client.initialize();

// =============================
// LOOP MENGAMBIL PESAN DARI LARAVEL
// =============================
async function startLoop() {
    const timestamp = Date.now();
    setInterval(async () => {
        try {
            // Ambil pesan 1 dari Laravel
            const res = await axios.get(
                `http://inventory.pramita.co.id:8000/api/v2/getway/whatsapp/status`
            );

            // Kalau 204 = tidak ada pesan
            if (res.status === 204) {
                return;
            }

            const message = res.data;
            const chatId = message.number.substring(1) + "@c.us";

            // Kirim WA
            await client.sendMessage(chatId, message.pesan);

            console.log(`Kirim ke ${chatId}: ${message.pesan}`);

            if (res.status === 204) {
                return;
            }
            // Update status ke Laravel
            if (!res) {
                console.log("Respon API tidak memiliki data");
                return;
            } else {
                await axios.get(
                    `http://inventory.pramita.co.id:8000/api/v2/getway/whatsapp/update/` +
                        message.token_code
                );
            }
        } catch (err) {
            console.log("Menunggu Pesan :", timestamp);
        }
    }, 5000);
}
