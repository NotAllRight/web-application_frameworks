import {Column, Entity, PrimaryGeneratedColumn, OneToMany} from "typeorm";
import { Product } from "../products/products.entity";
import { ApiProperty } from '@nestjs/swagger';

@Entity("categories")
export class Category {

    @PrimaryGeneratedColumn()
    id?: number;

    @ApiProperty({ example: 'Test name', description: 'The name of the category' })
    @Column()
    name?: string;

    @ApiProperty({ example: 'Test description', description: 'The description of the category' })
    @Column()
    description?: string;

    @OneToMany(() => Product, product => product.category)
    products?: Product[];
}
