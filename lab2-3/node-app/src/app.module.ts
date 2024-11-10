import {Module} from '@nestjs/common';
import {AppController} from './app.controller';
import {AppService} from './app.service';
import {CatsModule} from './cats/cats.module';
import {TagsModule} from './tags/tags.module';
import {ProductsModule} from './products/products.module';
import {TypeOrmModule} from '@nestjs/typeorm';
import { CategoriesModule } from './categories/categories.module';


@Module({
    imports: [
        CatsModule,
        // TagsModule,
        ProductsModule,
        TypeOrmModule.forRoot({
            type: 'postgres',
            // host: 'localhost',
            host: 'pg',
            port: 5432,
            username: 'pguser',
            password: 'password',
            database: 'nestjs',
            entities: [__dirname + '/**/*.entity{.ts,.js}'],
            synchronize: true,
            autoLoadEntities: true,
        }),
        CategoriesModule,
    ],
    controllers: [AppController],
    providers: [AppService],
})
export class AppModule {
}
