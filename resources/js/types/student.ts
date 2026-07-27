export interface Student {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    phone: string | null;
    student_id: string;
    date_of_birth: string | null;
    grade_level: string;
    status: 'active' | 'inactive' | 'graduated';
    created_at: string;
    updated_at: string;
    photo_url: string | null;
    photo: string | null;
    base64: string | null;
    blob: string | null;
}

export interface PaginatedStudents {
    data: Student[];
    links: { url: string | null; label: string; active: boolean }[];
    current_page: number;
    last_page: number;
    total: number;
    per_page: number;
}
