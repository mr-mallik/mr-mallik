// lib/mysql.js
import mysql from 'mysql2/promise';

const db = mysql.createPool({
  host: 'srv879.hstgr.io',
  user: 'u252460252_mrmallik',
  password: 'BBiVe:M7',
  database: 'u252460252_mrmallik',
});

export default db;