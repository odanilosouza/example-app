import { useEffect, useState } from "react";
import Link from "next/link";
import { MainLayout } from "@/components/layout/MainLayout";
import { api } from "@/services/api";

export default function PortalHomePage() {
  const [metrics, setMetrics] = useState({ documents: 0, reports: 0, visits: 0 });

  useEffect(() => {
    api.get("/api/dashboard/client").then((response) => {
      const totals = response.data?.data?.totals ?? {};
      setMetrics({
        documents: totals.documents ?? 0,
        reports: totals.reports ?? 0,
        visits: totals.visit_reports ?? 0,
      });
    });
  }, []);

  return (
    <MainLayout title="Painel do Portal">
      <div className="grid gap-6 sm:grid-cols-3">
        <div className="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
          <p className="text-sm text-slate-500">Documentos disponíveis</p>
          <p className="mt-4 text-3xl font-semibold text-slate-900">{metrics.documents}</p>
        </div>
        <div className="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
          <p className="text-sm text-slate-500">Relatórios criados</p>
          <p className="mt-4 text-3xl font-semibold text-slate-900">{metrics.reports}</p>
        </div>
        <div className="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
          <p className="text-sm text-slate-500">Visitas registradas</p>
          <p className="mt-4 text-3xl font-semibold text-slate-900">{metrics.visits}</p>
        </div>
      </div>

      <div className="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <Link href="/portal/documentos" className="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:border-indigo-500">
          <h2 className="text-lg font-semibold text-slate-900">Documentos</h2>
          <p className="mt-2 text-sm text-slate-600">Acesse contratos, notas e arquivos compartilhados.</p>
        </Link>
        <Link href="/portal/relatorios" className="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:border-indigo-500">
          <h2 className="text-lg font-semibold text-slate-900">Relatórios</h2>
          <p className="mt-2 text-sm text-slate-600">Veja métricas e análises dos serviços prestados.</p>
        </Link>
        <Link href="/portal/imagens" className="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:border-indigo-500">
          <h2 className="text-lg font-semibold text-slate-900">Imagens</h2>
          <p className="mt-2 text-sm text-slate-600">Galeria de imagens e comprovantes.</p>
        </Link>
      </div>
    </MainLayout>
  );
}
