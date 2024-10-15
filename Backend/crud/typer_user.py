from typing import Optional
from sqlalchemy.orm import Session
from models.user import User
from models.typer_user import TyperUser


def get_typer_user_by_id(db: Session, user_id: int) -> Optional[TyperUser]:
    user_db = db.query(User).filter(User.id == user_id).first()
    if user_db is None:
        return None
    return db.query(TyperUser).filter(TyperUser.id == user_db.typer_user_id).first()


def get_typer_user(db: Session) -> list[TyperUser]:
    return db.query(TyperUser).all()


def get_role_user_login(db: Session, current_user: dict):
    db_new = db.query(User).filter(User.id == current_user['sub']).first()
    if db_new is not None and db_new.typer_user:
        return db_new.typer_user.role
    return None


