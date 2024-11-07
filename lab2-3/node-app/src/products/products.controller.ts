import { Controller, Get, Post, Body } from '@nestjs/common';
import { ProductsService } from "./products.service";
import { Product } from "./products.interface";
import { ApiTags } from "@nestjs/swagger";

@Controller('products')
@ApiTags('Product')
export class ProductsController {
    constructor(private productsService: ProductsService) {}

    @Post()
    async create(@Body() product: Product): Promise<Product> {
        return await this.productsService.create(product);
    }

    @Get()
    async findAll(): Promise<Product[]> {
        return this.productsService.findAll();
    }
}
