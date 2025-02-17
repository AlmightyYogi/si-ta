const API_URL = "http://127.0.0.1:3000/api";

async function register (fullname, username, password) {
    const response = await fetch(`${API_URL}/register`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ fullname, username, password })
    });
    return response.json();
}

async function login (username, password) {
    const response = await fetch(`${API_URL}/login`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, password })
    });
    return response.json();
}

async function getProfile (token) {
    const response = await fetch(`${API_URL}/profile`, {
        method: "GET",
        headers: { "Authorization": `Bearer ${token}` }
    });
    return response.json();
}

async function logout (token) {
    const response = await fetch(`${API_URL}/logout`, {
        method: "POST",
        headers: { "Authorization": `Bearer ${token}` }
    });
    return response.json();
}