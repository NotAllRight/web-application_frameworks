import { NestFactory } from '@nestjs/core';
import { AppModule } from './app.module';
import { DocumentBuilder, SwaggerModule } from '@nestjs/swagger';

async function bootstrap() {
  const app = await NestFactory.create(AppModule);

  const config = new DocumentBuilder()
    .setTitle('NestJs API Documentation')
    .setDescription('Backend API for the NestJs application.')
    .setVersion('1.0')
    // .addBearerAuth(
    //   {
    //     type: 'http',
    //     scheme: 'bearer',
    //     bearerFormat: 'JWT',
    //     in: 'header',
    //   },
  //   'JWT', // Это название схемы авторизации
  // )
  .addOAuth2({
    type: 'oauth2',
    flows: {
      clientCredentials: {
        tokenUrl: 'http://localhost:8080/realms/maks/protocol/openid-connect/token',
        scopes: {
          'profile': 'profile',
          'email': 'email',
        },
      },
    },
  })
    .build();

  const document = SwaggerModule.createDocument(app, config);
  SwaggerModule.setup('api', app, document);

  await app.listen(3000);
}

bootstrap();