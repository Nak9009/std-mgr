export interface Department {
    id: number;
    name: string;
    description: string;
}

export interface PaginatedDepartments {
    data: Department[];
    links: { url: string | null; label: string; active: boolean }[];
    current_page: number;
    last_page: number;
    total: number;
}
