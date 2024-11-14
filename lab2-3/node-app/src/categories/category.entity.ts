import {Column, CreateDateColumn, Entity, PrimaryGeneratedColumn, UpdateDateColumn, OneToMany} from "typeorm";
import { Product } from "../products/products.entity";

@Entity("categories")
export class Category {
    @PrimaryGeneratedColumn()
    id: number;
    @Column()
    name: string;
    @Column()
    description: string;
    @OneToMany(() => Product, product => product.category)
    products: Product[];
}
