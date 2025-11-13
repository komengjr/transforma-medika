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
        host: "192.168.50.247",
        user: "agusraharjo",
        password: "Komenggaul28@",
        database: "db_inventaris",
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
            setTimeout(() => {
                connectDB();
            }, 30000);
        } else {
            setTimeout(() => {
                connectDB();
            }, 30000);
        }
    });
}
client.on("ready", () => {
    console.log("Client is ready!");
    function intervalfunction() {
        try {
            connection.connect(function (err) {
                if (err) {
                    setTimeout(connectDB, 30000);
                } else {
                    connection.query(
                        "select * from message where status = '0' LIMIT 1",
                        (err, result) => {
                            if (err) console.error(err);

                            result.forEach((message) => {
                                const code = `${message.pesan}`;
                                const number = `${message.number}`;
                                const text = `${code}`;
                                const chatid = number.substring(1) + "@c.us";

                                connection.query(
                                    "update message set status = '1' where id = " +
                                        message.id +
                                        " LIMIT 1",
                                    function (err) {
                                        if (err)
                                            console.log(
                                                "Ada Kesalahan Penggiriman"
                                            );
                                        client.sendMessage(chatid, text);

                                        console.log(`${message.pesan}`);
                                        console.log(
                                            "sukses kirim pesan ke " + chatid
                                        );
                                    }
                                );
                            });
                        }
                    );
                    // connection.query(
                    //   "select * from message where status = '0' LIMIT 1",
                    //   function (err, result) {
                    //     if (err) throw err;
                    //   }
                    // );
                }
            });
        } catch (err) {
            console.error("Database error:", err);
        }
    }
    setInterval(intervalfunction, 10000);
});
connectDB();
client.initialize();
