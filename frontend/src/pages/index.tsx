import Link from "next/link";
import { Button } from "@/components/ui/Button";
import { MainLayout } from "@/components/layout/MainLayout";

export default function Home() {
  return (
    <MainLayout title="Bem-vindo ao Portal do Cliente">
      <div className="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <p className="text-slate-600">Acesse seus documentos, relatórios e histórico em um único lugar.</p>
        <div className="mt-8 grid gap-4 sm:grid-cols-2">
          <Link href="/login" className="block">
            <Button as="span" className="w-full">Entrar</Button>
          </Link>
          <Link href="/cadastro" className="block">
            <Button as="span" variant="secondary" className="w-full">Criar conta</Button>
          </Link>
        </div>
      </div>
    </MainLayout>
  );
}
