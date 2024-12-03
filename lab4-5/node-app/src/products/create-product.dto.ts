import { IsString, IsNumber } from 'class-validator';
import { ApiProperty } from '@nestjs/swagger';

export class CreateProductDto {
    @ApiProperty({ example: 'Laptop', description: 'The name of the product' })
    @IsString()
    name: string;

    @ApiProperty({ example: 1500, description: 'The price of the product' })
    @IsNumber()
    price: number;

    @ApiProperty({ example: 'A high-end laptop', description: 'The description of the product' })
    @IsString()
    description: string;
}
