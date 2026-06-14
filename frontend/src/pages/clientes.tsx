import { MainLayout } from "@/components/layout/MainLayout";

export default function ClientesPage() {
  return (
    <MainLayout title="Clientes">
      <div className="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <p className="text-slate-600">Lista de clientes e contratos vinculados ao seu perfil.</p>
      </div>
    </MainLayout>
  );
}
