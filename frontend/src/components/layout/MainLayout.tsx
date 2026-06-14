import Link from "next/link";
import { ReactNode } from "react";

const navItems = [
  { href: "/", label: "Início" },
  { href: "/portal", label: "Portal" },
  { href: "/clientes", label: "Clientes" },
  { href: "/fale-conosco", label: "Fale Conosco" }
];

export function MainLayout({ title, children }: { title: string; children: ReactNode }) {
  return (
    <div className="min-h-screen bg-slate-50">
      <header className="border-b border-slate-200 bg-white shadow-sm">
        <div className="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6">
          <div>
            <Link href="/" className="text-lg font-semibold text-slate-900">
              Portal Customer
            </Link>
            <p className="text-xs text-slate-500">Área de clientes</p>
          </div>
          <nav className="hidden space-x-4 sm:flex">
            {navItems.map((item) => (
              <Link key={item.href} href={item.href} className="text-slate-700 hover:text-indigo-600">
                {item.label}
              </Link>
            ))}
          </nav>
        </div>
      </header>

      <main className="mx-auto max-w-7xl px-4 py-8 sm:px-6">
        <div className="mb-8">
          <h1 className="text-3xl font-semibold text-slate-900">{title}</h1>
        </div>
        {children}
      </main>
    </div>
  );
}
