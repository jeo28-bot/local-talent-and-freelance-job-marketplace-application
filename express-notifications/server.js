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





// --- Start server ---
const PORT = 3001;
app.listen(PORT, () => console.log(`Express notifications server running on port ${PORT}`));
