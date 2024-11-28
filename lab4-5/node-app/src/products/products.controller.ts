import { Controller, Get, Post, Body } from '@nestjs/common';
import { ProductsService } from "./products.service";
import { Product } from "./products.interface";
import { ApiTags } from "@nestjs/swagger";
import { Roles } from 'nest-keycloak-connect';

@Controller('products')
@ApiTags('Product')
export class ProductsController {
    constructor(private productsService: ProductsService) {}

    @Get()
    @Roles({ roles: ['user', 'admin'] })
    async findAll(): Promise<Product[]> {
        return this.productsService.findAll();
    }

    @Post()
    @Roles({ roles: ['admin'] })
    async create(@Body() product: Product): Promise<Product> {
        return await this.productsService.create(product);
    }

}
