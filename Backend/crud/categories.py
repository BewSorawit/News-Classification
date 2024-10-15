from sqlalchemy.orm import Session
from fastapi import HTTPException
from schemas.category import CategoryCreate
from models.categories import Category


def create_category(db: Session, category: CategoryCreate) -> Category:
    db_category = Category(name=category.name)
    db.add(db_category)
    db.commit()
    db.refresh(db_category)
    return db_category


def get_category_by_name(db: Session, name: str) -> Category:
    return db.query(Category).filter(Category.name == name).first()


def fetch_category_by_id(db: Session, id: int) -> Category:
    return db.query(Category).filter(Category.id == id).first()


def getAllCategories(db: Session) -> Category:
    return db.query(Category).all()
