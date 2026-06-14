import { FormEvent, useState } from "react";
import { useRouter } from "next/router";
import { MainLayout } from "@/components/layout/MainLayout";
import { Button } from "@/components/ui/Button";
import { Input } from "@/components/ui/Input";
import { register } from "@/services/api";
import { RegisterPayload } from "@/types";

export default function CadastroPage() {
  const router = useRouter();
  const [form, setForm] = useState<RegisterPayload>({
    full_name: "",
    company_name: "",
    cnpj: "",
    phone: "",
    email: "",
    password: "",
    password_confirmation: "",
  });
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");

  async function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();
    setError("");
    setSuccess("");

    try {
      await register(form);
      setSuccess("Cadastro realizado com sucesso. Você foi autenticado automaticamente.");
      router.push("/portal");
    } catch (err) {
      if (typeof err === "object" && err !== null && "response" in err) {
        const message = (err as any).response?.data?.message;
        setError(typeof message === "string" ? message : "Não foi possível concluir o cadastro.");
      } else {
        setError("Não foi possível concluir o cadastro.");
      }
    }
  }

  return (
    <MainLayout title="Cadastro">
      <div className="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <form onSubmit={handleSubmit} className="space-y-6">
          <div>
            <label className="block text-sm font-medium text-slate-700">Nome completo</label>
            <Input
              type="text"
              value={form.full_name}
              onChange={(event) => setForm({ ...form, full_name: event.target.value })}
              required
            />
          </div>
          <div>
            <label className="block text-sm font-medium text-slate-700">Razão Social / Empresa</label>
            <Input
              type="text"
              value={form.company_name}
              onChange={(event) => setForm({ ...form, company_name: event.target.value })}
              required
            />
          </div>
          <div>
            <label className="block text-sm font-medium text-slate-700">CNPJ</label>
            <Input
              type="text"
              value={form.cnpj}
              onChange={(event) => setForm({ ...form, cnpj: event.target.value })}
              required
            />
          </div>
          <div>
            <label className="block text-sm font-medium text-slate-700">E-mail</label>
            <Input
              type="email"
              value={form.email}
              onChange={(event) => setForm({ ...form, email: event.target.value })}
              required
            />
          </div>
          <div>
            <label className="block text-sm font-medium text-slate-700">Telefone</label>
            <Input
              type="text"
              value={form.phone}
              onChange={(event) => setForm({ ...form, phone: event.target.value })}
            />
          </div>
          <div>
            <label className="block text-sm font-medium text-slate-700">Senha</label>
            <Input
              type="password"
              value={form.password}
              onChange={(event) => setForm({ ...form, password: event.target.value })}
              required
            />
          </div>
          <div>
            <label className="block text-sm font-medium text-slate-700">Confirmar senha</label>
            <Input
              type="password"
              value={form.password_confirmation}
              onChange={(event) => setForm({ ...form, password_confirmation: event.target.value })}
              required
            />
          </div>
          {error ? <p className="text-sm text-red-600">{error}</p> : null}
          {success ? <p className="text-sm text-green-600">{success}</p> : null}
          <Button type="submit" className="w-full">Cadastrar</Button>
        </form>
      </div>
    </MainLayout>
  );
}
