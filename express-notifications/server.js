const express = require('express');
const cors = require('cors');
const mysql = require('mysql2/promise');

const app = express();
app.use(cors());
app.use(express.json());

// --- Database config ---
const dbConfig = {
    host: '127.0.0.1',
    user: 'root',
    password: '',
    database: 'job_marketplace',
};

// --- Test route ---
app.get('/', (req, res) => res.send('Server is running!'));

app.get('/api/notifications', async (req, res) => {
    try {
        const connection = await mysql.createConnection(dbConfig);

        const [rows] = await connection.execute(`
            SELECT title, data, created_at
            FROM notifications
            ORDER BY created_at DESC
            LIMIT 10
        `);

        const notifications = rows.map(row => ({
            title: row.title,
            data: row.data ? JSON.parse(row.data) : {},
            created_at: row.created_at ? new Date(row.created_at).toISOString() : new Date().toISOString()
        }));

        res.json(notifications);
        await connection.end();
    } catch (err) {
        console.error('DB fetch error:', err);
        res.status(500).json({ error: 'Database error' });
    }
});

// app.get('/api/announcements', async (req, res) => {
//     try {
//         const connection = await mysql.createConnection(dbConfig);

//         const [rows] = await connection.execute(`
//             SELECT id, title, audience, message, release_date, status, created_at, updated_at
//             FROM announcements
//             ORDER BY created_at DESC
//         `);

//         res.json(rows);

//         await connection.end();
//     } catch (error) {
//         console.error("Error fetching announcements:", error);
//         res.status(500).json({ error: "Database error" });
//     }
// });

app.post('/api/announcements', async (req, res) => {
    const { title, audience, release_date, message } = req.body;

    if (!title || !audience || !release_date || !message) {
        return res.status(400).json({ success: false, error: "All fields are required." });
    }

    let connection;

    try {
        connection = await mysql.createConnection(dbConfig);

        const [result] = await connection.execute(
            `INSERT INTO announcements (title, audience, message, release_date, status, created_at, updated_at)
             VALUES (?, ?, ?, ?, 'active', NOW(), NOW())`,
            [title, audience, message, release_date]
        );

        return res.json({ success: true, id: result.insertId });

    } catch (error) {
        console.error("Error saving announcement:", error);

        return res.status(500).json({ success: false, error: "Database error." });

    } finally {
        if (connection) await connection.end();
    }
});

app.get('/api/announcements', async (req, res) => {
    try {
        const connection = await mysql.createConnection(dbConfig);

        const [rows] = await connection.execute(`
            SELECT id, title, audience, message, release_date, status, created_at, updated_at
            FROM announcements
            ORDER BY created_at DESC
        `);

        await connection.end();
        res.json(rows);

    } catch (error) {
        console.error("Error fetching announcements:", error);
        res.status(500).json({ error: "Database error" });
    }
});

app.delete('/api/announcements/:id', async (req, res) => {
    const { id } = req.params;
    let connection;

    try {
        connection = await mysql.createConnection(dbConfig);
        const [result] = await connection.execute(
            "DELETE FROM announcements WHERE id = ?",
            [id]
        );

        if (result.affectedRows === 0) {
            return res.status(404).json({ success: false, error: "Announcement not found" });
        }

        res.json({ success: true, message: "Announcement deleted" });
    } catch (err) {
        console.error("Error deleting announcement:", err);
        res.status(500).json({ success: false, error: "Database error" });
    } finally {
        if (connection) await connection.end();
    }
});






// --- Start server ---
const PORT = 3001;
app.listen(PORT, () => console.log(`Express notifications server running on port ${PORT}`));
