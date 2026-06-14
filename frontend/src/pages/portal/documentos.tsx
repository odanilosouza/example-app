import { MainLayout } from "@/components/layout/MainLayout";

export default function DocumentosPage() {
  return (
    <MainLayout title="Documentos">
      <div className="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <p className="text-slate-600">Em breve, seus documentos estarão disponíveis aqui.</p>
      </div>
    </MainLayout>
  );
}
