from typing import Optional
from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from models.user import User
from models.typer_user import RoleEnum
from crud.typer_user import get_typer_user_by_id
from utils.auth import get_current_user
from schemas.news import NewsCreatedResponse, NewsCreate, NewsUpdate, NewsUpdateResponse, NewsResponse
from database import get_db
from models.news import News
from crud.news import create_news, update_news, getAll, getNewsById

router = APIRouter()


def get_writer_user(db: Session, current_user: dict) -> Optional[User]:
    user_id = current_user.get("sub")
    typer_user = get_typer_user_by_id(db, user_id)

    if not typer_user or typer_user.role != RoleEnum.writer:
        raise HTTPException(
            status_code=status.HTTP_403_FORBIDDEN,
            detail="You are not authorized to create news.",
        )

    return user_id


def get_editor_user(db: Session, current_user: dict) -> Optional[User]:
    user_id = current_user.get("sub")
    typer_user = get_typer_user_by_id(db, user_id)

    if not typer_user or typer_user.role != RoleEnum.editor:
        raise HTTPException(
            status_code=status.HTTP_403_FORBIDDEN,
            detail="You are not authorized to update news.",
        )

    return user_id


def get_viewer_user(db: Session, current_user: dict) -> Optional[User]:
    user_id = current_user.get("sub")
    typer_user = get_typer_user_by_id(db, user_id)
    print(typer_user.role)
    if not typer_user or (typer_user.role not in [RoleEnum.viewer, RoleEnum.writer, RoleEnum.editor, RoleEnum.admin]):
        raise HTTPException(
            status_code=status.HTTP_403_FORBIDDEN,
            detail="You are not authorized to view news.",
        )

    return user_id


@router.get('/{news_id}', response_model=NewsResponse)
def get_news_by_id_item(
    news_id: int,
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):
    get_viewer_user(db, current_user)
    news = getNewsById(db, news_id)
    return news


@router.get('/', response_model=list[NewsResponse])
def get_all_news_item(
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):
    get_viewer_user(db, current_user)
    news_all = getAll(db)
    return news_all


@router.post('/', response_model=NewsCreatedResponse, status_code=status.HTTP_201_CREATED)
def create_news_item(
    news: NewsCreate,
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):
    writer_id = get_writer_user(db, current_user)

    created_news = create_news(db, news, writer_id)

    if not created_news:
        raise HTTPException(status_code=status.HTTP_400_BAD_REQUEST,
                            detail="Failed to create news item.")

    return NewsCreatedResponse(success=True, data=created_news)


@router.put('/{news_id}', response_model=NewsUpdateResponse)
def update_news_item(
    news_id: int,
    news_update: NewsUpdate,
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):
    editor_id = get_editor_user(db, current_user)
    updated_news = update_news(db, news_id, news_update, editor_id)

    return NewsUpdateResponse(success=True, data=updated_news)
