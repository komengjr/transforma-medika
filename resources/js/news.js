const { Client, LocalAuth, MessageMedia } = require("whatsapp-web.js");
const qrcode = require("qrcode-terminal");
const axios = require("axios");

// Laravel API URL
// const API = "http://inventory.pramita.co.id:8000/api/v2/getway/whatsapp/status";

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
    setInterval(async () => {
        try {
            // Ambil pesan 1 dari Laravel
            const res = await axios.get(
                `https://innoventra.site/api/v2/getway/whatsapp`
            );

            // Kalau 204 = tidak ada pesan
            if (res.status === 204) {
                return;
            }

            const message = res.data;
            const chatId = message.v_log_whatsapp_number.substring(1) + "@c.us";
            const isRegistered = await client.isRegisteredUser(chatId);

            if (isRegistered) {
                // Kirim WA
                await client.sendMessage(chatId, message.v_log_whatsapp_text);
                console.log(
                    `Kirim ke ${chatId}: ${message.v_log_whatsapp_text}`
                );
                // KIRIM GAMBAR
                if (message.v_log_whatsapp_picture == "0") {
                    console.log("Picture Tidak Ada");
                } else {
                    const media = new MessageMedia(
                        "image/png",
                        `${message.v_log_whatsapp_picture}`,
                        `${message.v_log_whatsapp_filename}` + ".jpg"
                    );
                    client.sendMessage(chatId, media);
                    console.log(
                        "sukses kirim " +
                            `${message.v_log_whatsapp_filename}` +
                            ".jpg"
                    );
                }
                // KIRIM PDF
                if (message.v_log_whatsapp_file == "N") {
                    console.log("File Tidak Ada");
                } else {
                    const media = new MessageMedia(
                        "application/pdf",
                        `${message.v_log_whatsapp_file}`,
                        `${message.v_log_whatsapp_filename}` + ".pdf"
                    );
                    client.sendMessage(chatId, media);
                    console.log(
                        "sukses kirim " +
                            `${message.v_log_whatsapp_filename}` +
                            ".pdf"
                    );
                }
                await axios.post(
                    `https://innoventra.site/api/v2/getway/whatsapp-update`,
                    {
                        code: message.v_log_whatsapp_code,
                        status: 1,
                    }
                );
            } else {
                await axios.post(
                    `https://innoventra.site/api/v2/getway/whatsapp-update`,
                    {
                        code: message.v_log_whatsapp_code,
                        status: 2,
                    }
                );
                console.log("Nomor tidak terdaftar di WhatsApp");
            }
        } catch (err) {
            console.log("Loading :", err.message);
        }
    }, 30000);
}
