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
    // @Column({ type: 'varchar', nullable: true })
    // image: string | null;
    // @CreateDateColumn({ type: "timestamp", default: () => "CURRENT_TIMESTAMP(6)" })
    // public created_at: Date;
    // @UpdateDateColumn({ type: "timestamp", default: () => "CURRENT_TIMESTAMP(6)", onUpdate: "CURRENT_TIMESTAMP(6)" })
    // public updated_at: Date;

    @OneToMany(() => Product, product => product.category)
    products: Product[];
}
