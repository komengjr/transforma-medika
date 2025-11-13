const { Client, LocalAuth, MessageMedia } = require("whatsapp-web.js");
const qrcode = require("qrcode-terminal");
const mysql = require("mysql2");
let connection;

const client = new Client({
    authStrategy: new LocalAuth({
        dataPath: "dataClient",
    }),
});
client.on("qr", (qr) => {
    qrcode.generate(qr, { small: true });
});
client.on("message", (msg) => {
    if (msg.body == "!ping") {
        msg.reply("pong");
    }
});
client.on("authenticated", () => {
    console.log("Authenticated!");
});
client.on("auth_failure", (msg) => {
    console.error("Authentication failure", msg);
});
client.on("disconnected", (reason) => {
    console.log("Client was disconnected", reason);
    client.destroy();
});

function connectDB() {
    connection = mysql.createConnection({
        host: "153.92.15.28",
        user: "u621123533_innoventra",
        password: "Komenggaul28@",
        database: "u621123533_innoventra",
    });

    connection.connect((err) => {
        if (err) {
            console.log("menunggu koneksi");
            setTimeout(() => {
                connectDB();
            }, 30000);
        } else {
            console.log("berhasil");
        }
    });

    connection.on("error", (err) => {
        if (err.code === "PROTOCOL_CONNECTION_LOST") {
            console.log("menunggu koneksi");
            setTimeout(() => {
                connectDB();
            }, 30000);
        } else {
            console.log("menunggu koneksi");
            setTimeout(() => {
                connectDB();
            }, 30000);
        }
    });
}
client.on("ready", () => {
    console.log("Client is ready!");
    function intervalfunction() {
        connection.query(
            "select * from v_log_whatsapp where v_log_whatsapp_status = '0' LIMIT 1",
            function (err, result) {
                if (err) console.error(err);
                result.forEach((message) => {
                    const code = `${message.v_log_whatsapp_text}`;
                    const number = `${message.v_log_whatsapp_number}`;
                    const text = `${code}`;
                    const chatid = number.substring(1) + "@c.us";

                    connection.query(
                        "update v_log_whatsapp set v_log_whatsapp_status = '1' where id_v_log_whatsapp = " +
                            message.id_v_log_whatsapp +
                            " LIMIT 1",
                        function (err) {
                            if (err) console.error(err);
                            client.sendMessage(chatid, text);
                            // KIRIM JPG
                            if (`${message.v_log_whatsapp_picture}` == "0") {
                            } else {
                                const media = new MessageMedia(
                                    "image/png",
                                    `${message.v_log_whatsapp_picture}`,
                                    `${message.v_log_whatsapp_filename}` +
                                        ".jpg"
                                );
                                client.sendMessage(chatid, media);
                                console.log(
                                    "sukses kirim " +
                                        `${message.v_log_whatsapp_filename}` +
                                        ".jpg"
                                );
                            }
                            // KIRIM PDF
                            if (`${message.v_log_whatsapp_file}` == "N") {
                            } else {
                                const media = new MessageMedia(
                                    "application/pdf",
                                    `${message.v_log_whatsapp_file}`,
                                    `${message.v_log_whatsapp_filename}` +
                                        ".pdf"
                                );
                                client.sendMessage(chatid, media);
                                console.log(
                                    "sukses kirim " +
                                        `${message.v_log_whatsapp_filename}` +
                                        ".pdf"
                                );
                            }
                            console.log(`${message.v_log_whatsapp_text}`);
                            console.log("sukses kirim pesan ke " + chatid);
                        }
                    );
                });
            }
        );
    }
    setInterval(intervalfunction, 5000);
});
connectDB();
client.initialize();
