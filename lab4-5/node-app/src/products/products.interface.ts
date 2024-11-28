import { Category } from '../categories/category.entity';

export interface Product {
    id?: number;
    name: string;
    description: string;
    price: number;
    category?: Category;
}