import {Body, Controller, Delete, Get, NotFoundException, Post, Query, Put, Param} from '@nestjs/common';
import {Pagination} from "nestjs-typeorm-paginate";
import {Category} from "./category.entity";
import {CategoryInterface} from "./categories.interface"
import {CategoriesService} from "./categories.service";
import { Roles, Unprotected } from 'nest-keycloak-connect';
import { ApiOAuth2, ApiTags, ApiOperation, ApiParam, ApiBody, ApiResponse } from '@nestjs/swagger';


@Controller('categories')
export class CategoriesController {
    constructor(private readonly categoriesService: CategoriesService) {}
    @Get('')
    @ApiOAuth2([])
    @Roles({ roles: ['user', 'admin'] })
    @ApiOperation({ summary: 'Get a list of categories' })
    @ApiResponse({ status: 200, description: 'List of all categories', type: [Category] })
    // index(@Query('page') page = 1,  @Query('limit') limit = 10): Promise<Pagination<Category>> {
    //     return this.categoriesService.paginate({limit:limit, page:  page});
    // }
    async findAll(): Promise<Category[]> {
        return this.categoriesService.findAll();
    }

    @Get(':id')
    @ApiOAuth2([])
    @Roles({ roles: ['admin'] })
    @ApiOperation({ summary: 'Get a category by ID' })
    @ApiResponse({ status: 200, description: 'Category found', type: Category })
    @ApiResponse({ status: 404, description: 'Category not found' })
    show(@Param('id') id: number): Promise<Category | null> {
        return this.categoriesService.findOne(id);
    }

    @Post('')
    @ApiOAuth2([])
    @Roles({ roles: ['admin'] })
    @ApiOperation({ summary: 'Create a new category' })
    @ApiBody({ description: 'Category data to create', type: Category })
    @ApiResponse({ status: 201, description: 'Category successfully created', type: Category })
    store(@Body() categoryData: Category ): Promise<Category> {
        return this.categoriesService.create(categoryData);
    }

    @Put(':id')
    @ApiOAuth2([])
    @Roles({ roles: ['admin'] })
    @ApiOperation({ summary: 'Update a category by ID' })
    @ApiParam({ name: 'id', type: 'number', description: 'Category ID' })
    @ApiBody({ description: 'Updated category data', type: CategoryInterface })
    @ApiResponse({ status: 200, description: 'Category successfully updated', type: CategoryInterface })
    @ApiResponse({ status: 404, description: 'Category not found' })
    async update(@Param('id') id: number, @Body() categoryData: CategoryInterface): Promise<Category> {
        const category = await this.categoriesService.findOne(id);
        if (!category) {
            throw new NotFoundException(`Category #${id} not found`);
        }
        return this.categoriesService.update(id, categoryData);
    }



    @Delete(':id')
    @ApiOAuth2([])
    @Roles({ roles: ['admin'] })
    @ApiOperation({ summary: 'Delete a category by ID' })
    @ApiParam({ name: 'id', type: 'number', description: 'Category ID' })
    @ApiResponse({ status: 200, description: 'Category successfully deleted' })
    @ApiResponse({ status: 404, description: 'Category not found' })
    delete(@Param('id') id:number): void {
        const deleted =  this.categoriesService.remove(id);
        if (!deleted) {
            throw new NotFoundException(`Category #${id} not found`);
        }
    }
}
