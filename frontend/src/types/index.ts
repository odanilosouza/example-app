export type LoginPayload = {
  cnpj: string;
  password: string;
};

export type RegisterPayload = {
  full_name: string;
  company_name: string;
  cnpj: string;
  phone?: string;
  email: string;
  password: string;
  password_confirmation: string;
};

export type Client = {
  id: number;
  name: string;
  email: string;
  company: string;
  phone?: string;
};

export type Document = {
  id: number;
  title: string;
  url: string;
  description?: string;
};
