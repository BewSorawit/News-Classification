from fastapi import FastAPI
from database import engine, Base
from models.user import User
from models.news import News
from models.typer_user import TyperUser
from models.news_type import NewsType
from models.categories import Category
from routers.admin import router as admin_router
from routers.auth import router as auth_router
from routers.news import router as new_router
from routers.categories import router as category_router
from routers.typer_user import router as typer_user_router
from routers.news_type import router as news_type_router

from fastapi.middleware.cors import CORSMiddleware
import uvicorn

app = FastAPI()
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)

Base.metadata.create_all(bind=engine)

app.include_router(admin_router, prefix='/users', tags=['users'])
app.include_router(new_router, prefix='/news', tags=['news'])
app.include_router(category_router, prefix='/categories', tags=['categories'])
app.include_router(typer_user_router, prefix='/typer_user_router',
                   tags=['typer_user_router'])
app.include_router(news_type_router, prefix='/news_type',
                   tags=['news_type'])

app.include_router(auth_router)

if __name__ == "__main__":
    uvicorn.run("main:app", port=8000, log_level="info", reload=True)
