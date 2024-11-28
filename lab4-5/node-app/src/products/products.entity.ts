import {Column, Entity, ManyToOne, PrimaryGeneratedColumn} from "typeorm";
import { Category } from "../categories/category.entity";

@Entity("products")
export class Product {
    @PrimaryGeneratedColumn()
    id: number;

    @Column()
    name: string;

    @Column()
    description: string;

    @Column('float')
    price: number;

    @ManyToOne(() => Category, category => category.products, { eager: true })
    category: Category;
}
