import { Injectable, NotFoundException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { DeleteResult, Repository } from 'typeorm';
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
                if (product.category && product.category.id) {
                    const category = await this.categoriesService.findOne(product.category.id);
                    if (category) {
                        product.category = category; // Убедимся, что продукт связан с существующей категорией
                        await this.productRepository.save(product);
                    } else {
                        console.error(`Category with id ${product.category.id} does not exist.`);
                    }
                } else {
                    console.error(`Product category id is undefined or invalid.`);
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

    public findOne(id: number): Promise<Product | null> {
        return this.productRepository.findOneBy({ id });
    }

    async update(id: number, productData: ProductInterface): Promise<Product> {
        // Находим продукт по ID с отношением к категории
        const existingProduct = await this.productRepository.findOne({ where: { id }, relations: ['category'] });
    
        if (!existingProduct) {
          throw new NotFoundException(`Product with ID ${id} not found`);
        }
    
        // Обновляем поля продукта
        Object.assign(existingProduct, productData);
    
        // Если передан объект категории, обновляем связь с категорией
        if (productData.category) {
            const categoryId = productData.category.id;
            if (categoryId === undefined) {
                throw new NotFoundException(`ID unefined`);
            }
            const category = await this.categoriesService.findOne(categoryId);  // Находим категорию по ID
            if (!category) {
                throw new NotFoundException(`Category with ID ${categoryId} not found`);
            }
            existingProduct.category = category;  // Обновляем связь с категорией
        }
    
        // Сохраняем обновленный продукт
        return this.productRepository.save(existingProduct);
    }

    public remove(id: number): Promise<DeleteResult> {
        return this.productRepository.delete(id);
    }
}
