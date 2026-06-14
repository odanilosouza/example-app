import axios from "axios";
import { LoginPayload, RegisterPayload } from "@/types";

const baseURL = process.env.NEXT_PUBLIC_API_URL ?? "http://127.0.0.1:8002";

const tokenKey = "portal_api_token";

function getToken(): string | null {
  return typeof window !== "undefined" ? localStorage.getItem(tokenKey) : null;
}

function setToken(token: string) {
  if (typeof window !== "undefined") {
    localStorage.setItem(tokenKey, token);
  }
  api.defaults.headers.common.Authorization = `Bearer ${token}`;
}

function removeToken() {
  if (typeof window !== "undefined") {
    localStorage.removeItem(tokenKey);
  }
  delete api.defaults.headers.common.Authorization;
}

export function isAuthenticated(): boolean {
  return Boolean(getToken());
}

export const api = axios.create({
  baseURL,
  headers: {
    "Content-Type": "application/json"
  }
});

const token = getToken();
if (token) {
  api.defaults.headers.common.Authorization = `Bearer ${token}`;
}

export async function login(payload: LoginPayload) {
  const response = await api.post("/api/auth/login", payload);
  const token = response.data?.token ?? response.data?.data?.token;

  if (token) {
    setToken(token);
  }

  return response;
}

export async function register(payload: RegisterPayload) {
  const response = await api.post("/api/auth/register", payload);
  const token = response.data?.token ?? response.data?.data?.token;

  if (token) {
    setToken(token);
  }

  return response;
}

export async function logout() {
  const response = await api.post("/api/auth/logout");
  removeToken();
  return response;
}

export async function fetchClients() {
  return api.get("/api/clients");
}

export async function fetchDocuments() {
  return api.get("/api/documents");
}
