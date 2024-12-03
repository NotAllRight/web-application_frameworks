import { Controller, Get, Post, Put, Delete, Body, Param, NotFoundException } from '@nestjs/common';
import { ProductsService } from "./products.service";
import { Product } from "./products.interface";
import { ApiOAuth2, ApiTags, ApiOperation, ApiBody, ApiParam, ApiResponse } from '@nestjs/swagger';
import { Roles } from 'nest-keycloak-connect';

@Controller('products')
@ApiTags('Product')
export class ProductsController {
    constructor(private productsService: ProductsService) {}

    @Get()
    @ApiOAuth2([])
    @Roles({ roles: ['user', 'admin'] })
    @ApiOperation({ summary: 'Get all products' })
    @ApiResponse({ status: 200, description: 'List of all products', type: [Product] })
    async findAll(): Promise<Product[]> {
        return this.productsService.findAll();
    }

    @Get(':id')
    @ApiOAuth2([])
    @Roles({ roles: ['admin'] })
    @ApiOperation({ summary: 'Get product by ID' })
    @ApiResponse({ status: 200, description: 'Product found', type: Product })
    @ApiResponse({ status: 404, description: 'Product not found' })
    show(@Param('id') id: number): Promise<Product | null> {
        return this.productsService.findOne(id);
    }

    @Post()
    @ApiOAuth2([])
    @Roles({ roles: ['admin'] })
    @ApiOperation({ summary: 'Create a new product' })
    @ApiBody({ description: 'Product data', type: Product })
    @ApiResponse({ status: 201, description: 'Product successfully created', type: Product })
    async create(@Body() product: Product): Promise<Product> {
        return await this.productsService.create(product);
    }

    @Put(':id')
    @ApiOAuth2([])
    @Roles({ roles: ['admin'] })
    @ApiOperation({ summary: 'Update a product by ID' })
    @ApiParam({ name: 'id', type: 'number', description: 'Product ID' })
    @ApiBody({ description: 'Updated product data', type: Product })
    @ApiResponse({ status: 200, description: 'Product successfully updated', type: Product })
    @ApiResponse({ status: 404, description: 'Product not found' })
    async update(@Param('id') id: number, @Body() product: Product): Promise<Product> {
        return this.productsService.update(id, product);
    }

    @Delete(':id')
    @ApiOAuth2([])
    @Roles({ roles: ['admin'] })
    @ApiOperation({ summary: 'Delete a product by ID' })
    @ApiResponse({ status: 200, description: 'Product successfully deleted' })
    @ApiResponse({ status: 404, description: 'Product not found' })
    async delete(@Param('id') id: number): Promise<void> {
        const deleted = await this.productsService.remove(id);
    
        if (!deleted.affected) {
          throw new NotFoundException(`Product with ID #${id} not found`);
        }
      }

}
