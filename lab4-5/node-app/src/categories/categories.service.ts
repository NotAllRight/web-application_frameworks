import { Injectable, NotFoundException } from '@nestjs/common';
import { InjectRepository } from "@nestjs/typeorm";
import { Category } from "./category.entity";
import { DeleteResult, Repository } from "typeorm";
import { IPaginationOptions, paginate, Pagination } from "nestjs-typeorm-paginate";

@Injectable()
export class CategoriesService {
    constructor(
        @InjectRepository(Category)
        private repository: Repository<Category>,
    ) {}

    private readonly categories: Omit<Category, 'id'>[] = [
        {
            name: 'Fruits',
            description: 'All kinds of fruits',
            products: [],
        },
        {
            name: 'Vegetables',
            description: 'Various types of vegetables',
            products: [],
        },
    ];

    public create(categoryData: Category): Promise<Category> {
        return this.repository.save(categoryData);
    }

    public findAll(): Promise<Category[]> {
        return this.repository.find();
    }

    public findOne(id: number): Promise<Category | null> {
        return this.repository.findOneBy({ id });
    }

    public findOneByName(name: string): Promise<Category | null> {
        return this.repository.findOne({ where: { name } });
    }

    async update(id: number, categoryData: Category): Promise<Category> {
        // Находим категорию по ID
        const category = await this.findOne(id);
        if (!category) {
            throw new NotFoundException(`Category #${id} not found`);
        }
    
        // Обновление только переданных полей
        Object.assign(category, categoryData);
        return this.repository.save(category);
    }

    public remove(id: number): Promise<DeleteResult> {
        return this.repository.delete(id);
    }

    public paginate(options: IPaginationOptions): Promise<Pagination<Category>> {
        return paginate<Category>(this.repository, options);
    }

    async createCategories() {
        for (const category of this.categories) {
            // Проверяем, существует ли категория с таким именем
            const existingCategory = await this.repository.findOne({ where: { name: category.name } });
            if (!existingCategory) {
                const newCategory = this.repository.create(category);
                await this.repository.save(newCategory);
            }
        }
    }
}
