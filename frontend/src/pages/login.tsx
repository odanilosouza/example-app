import { FormEvent, useState } from "react";
import { useRouter } from "next/router";
import { Button } from "@/components/ui/Button";
import { Input } from "@/components/ui/Input";
import { login } from "@/services/api";
import { MainLayout } from "@/components/layout/MainLayout";

export default function LoginPage() {
  const router = useRouter();
  const [cnpj, setCnpj] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");

  async function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();
    setError("");

    try {
      await login({ cnpj, password });
      router.push("/portal");
    } catch (err) {
      const message = (err as any)?.response?.data?.message;
      setError(typeof message === "string" ? message : "Não foi possível fazer login. Verifique suas credenciais.");
    }
  }

  return (
    <MainLayout title="Login">
      <div className="max-w-md rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <form onSubmit={handleSubmit} className="space-y-6">
          <div>
            <label className="block text-sm font-medium text-slate-700">CNPJ</label>
            <Input
              type="text"
              value={cnpj}
              maxLength={4}
              placeholder="Somente os 4 primeiros números"
              onChange={(event) => {
                const digits = event.target.value.replace(/\D/g, "").slice(0, 4);
                setCnpj(digits);
              }}
              required
            />
          </div>
          <div>
            <label className="block text-sm font-medium text-slate-700">Senha</label>
            <Input type="password" value={password} onChange={(event) => setPassword(event.target.value)} required />
          </div>
          {error ? <p className="text-sm text-red-600">{error}</p> : null}
          <Button type="submit" className="w-full">Entrar</Button>
        </form>
      </div>
    </MainLayout>
  );
}
