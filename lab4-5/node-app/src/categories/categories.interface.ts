import { IsString, IsOptional, IsNotEmpty, IsNumber } from 'class-validator';
import { Product } from "../products/products.entity";
import { ApiProperty } from '@nestjs/swagger';

export class CategoryInterface {

    @IsOptional()
    @IsNumber()
    id?: number;

    @ApiProperty({ example: 'Test name', description: 'The name of the category' })
    @IsOptional()
    @IsString()
    name?: string;

    @ApiProperty({ example: 'Test description', description: 'The description of the category' })
    @IsOptional()
    @IsString()
    description?: string;

    @IsOptional()
    @IsNotEmpty()
    products?: Product[];
}