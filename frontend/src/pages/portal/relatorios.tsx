import { MainLayout } from "@/components/layout/MainLayout";

export default function RelatoriosPage() {
  return (
    <MainLayout title="Relatórios">
      <div className="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <p className="text-slate-600">Visualize relatórios recentes e indicadores.</p>
      </div>
    </MainLayout>
  );
}
