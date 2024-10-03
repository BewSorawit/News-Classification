from fastapi import FastAPI
from database import engine, Base
from models.user import User
from models.news import News
from models.typer_user import TyperUser
from models.news_type import NewsType
from routers.user import router as user_router
from routers.auth import router as auth_router

import uvicorn

app = FastAPI()
Base.metadata.create_all(bind=engine)


app.include_router(user_router)
app.include_router(auth_router)

if __name__ == "__main__":
    uvicorn.run("main:app", port=8000, log_level="info", reload=True)
