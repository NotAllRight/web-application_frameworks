import { IsString, IsNumber, IsOptional, IsNotEmpty } from 'class-validator';
import { Category } from '../categories/category.entity';
import { ApiProperty } from '@nestjs/swagger';

export class Product {
    
    @IsOptional()
    @IsNumber()
    id?: number;
    
    @ApiProperty({ example: 'Test name', description: 'The name of the product' })
    @IsOptional()
    @IsString()
    name?: string;

    @ApiProperty({ example: 'Test description', description: 'The description of the product' })
    @IsOptional()
    @IsString()
    description?: string;

    @ApiProperty({ example: 1500, description: 'The price of the product' })
    @IsOptional()
    @IsNumber()
    price?: number;

    @ApiProperty({ example: 1, description: 'The category of the product' })
    @IsOptional()
    @IsNotEmpty()
    category?: Category;
}