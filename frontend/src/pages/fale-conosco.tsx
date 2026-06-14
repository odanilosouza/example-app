import { MainLayout } from "@/components/layout/MainLayout";
import { Button } from "@/components/ui/Button";

export default function FaleConoscoPage() {
  return (
    <MainLayout title="Fale Conosco">
      <div className="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <p className="text-slate-600">Envie uma mensagem direto para o time de atendimento.</p>
        <div className="mt-6">
          <Button variant="secondary">Em breve</Button>
        </div>
      </div>
    </MainLayout>
  );
}
