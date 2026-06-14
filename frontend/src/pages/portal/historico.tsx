import { MainLayout } from "@/components/layout/MainLayout";

export default function HistoricoPage() {
  return (
    <MainLayout title="Histórico">
      <div className="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <p className="text-slate-600">Acompanhe histórico de ações, downloads e acessos.</p>
      </div>
    </MainLayout>
  );
}
