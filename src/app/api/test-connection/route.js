// app/api/test-connection/route.js
import db from '../../../lib/mysql';

export async function GET(request) {
  try {
    // Perform a simple query to check the connection
    await db.query('SELECT 1 + 1 AS result');
    return new Response(JSON.stringify({ message: 'Connection successful' }), {
      status: 200,
      headers: {
        'Content-Type': 'application/json',
      },
    });
  } catch (error) {
    console.error('Database connection failed:', error);
    return new Response(JSON.stringify({ message: 'Connection failed' }), {
      status: 500,
      headers: {
        'Content-Type': 'application/json',
      },
    });
  }
}