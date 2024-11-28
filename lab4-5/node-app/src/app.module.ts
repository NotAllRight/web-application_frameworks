import {Module} from '@nestjs/common';
import {AppController} from './app.controller';
import {AppService} from './app.service';
import {ProductsModule} from './products/products.module';
import {TypeOrmModule} from '@nestjs/typeorm';
import { CategoriesModule } from './categories/categories.module';
import {
    KeycloakConnectModule,
    ResourceGuard,
    RoleGuard,
    AuthGuard,
    TokenValidation
  } from 'nest-keycloak-connect';
import { APP_GUARD } from '@nestjs/core';

@Module({
    imports: [
        KeycloakConnectModule.register({
          authServerUrl: 'http://localhost:8080',
          realm: 'Maks',
          clientId: 'node-app',
          secret: '3kHLvvSccUG8Z7ciYOs4pjrg9FF6Pep9',
          tokenValidation: TokenValidation.NONE, // optional

        }),
        ProductsModule,
        CategoriesModule,
        TypeOrmModule.forRoot({
            type: 'postgres',
            host: 'pg',
            port: 5432,
            username: 'pguser',
            password: 'password',
            database: 'nestjs',
            entities: [__dirname + '/**/*.entity{.ts,.js}'],
            synchronize: true,
            autoLoadEntities: true,
        }),
    ],
    controllers: [AppController],
    providers: [
        AppService,
        {
          provide: APP_GUARD,
          useClass: AuthGuard,
        },
        {
          provide: APP_GUARD,
          useClass: ResourceGuard,
        },
        {
          provide: APP_GUARD,
          useClass: RoleGuard,
        },
      ],
})
export class AppModule {
}