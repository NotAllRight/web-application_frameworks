from fastapi import FastAPI

app = FastAPI()

@app.get("/python-fastapi")
async def read_root():
    return {"message": "Hello, FastAPI!"}
