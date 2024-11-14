import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Product } from './products.entity';
import { Category } from '../categories/category.entity';
import { Product as ProductInterface } from './products.interface';
import { CategoriesService } from '../categories/categories.service';

@Injectable()
export class ProductsService {
    private readonly products: Omit<Product, 'id'>[] = [
        {
            name: 'Apple',
            description: 'Very sweet',
            price: 30.99,
            category: { name: 'Fruits' } as Category,
        },
        {
            name: 'Onion',
            description: 'So nice onion',
            price: 43.55,
            category: { name: 'Vegetables' } as Category,
        },
    ];

    constructor(
        @InjectRepository(Product)
        private readonly productRepository: Repository<Product>,
        private readonly categoriesService: CategoriesService,
    ) {
        this.initializeProducts();
    }

    private async initializeProducts() {
        // Сначала убедимся, что категории существуют
        await this.categoriesService.createCategories();

        const existingProducts = await this.productRepository.find();

        if (existingProducts.length === 0) {
            for (const product of this.products) {
                const category = await this.categoriesService.findOneByName(product.category.name);
                if (category) {
                    product.category = category; // Убедимся, что продукт связан с существующей категорией
                    await this.productRepository.save(product);
                } else {
                    console.error(`Category with name ${product.category.name} does not exist.`);
                }
            }
        }
    }

    async create(product: ProductInterface): Promise<Product> {
        const newProduct = this.productRepository.create(product);
        return await this.productRepository.save(newProduct);
    }

    async findAll(): Promise<Product[]> {
        return await this.productRepository.find({ relations: ['category'] });
    }
}
