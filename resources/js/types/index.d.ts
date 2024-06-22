export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

type Settings = {
    format: 'xml' | 'txt',
    path: string
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    },
    settings: Settings
};
