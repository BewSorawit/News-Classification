from sqlalchemy.orm import Session
from models.typer_user import TyperUser


def get_typer_user_by_id(db: Session, typer_user_id: int) -> TyperUser:
    return db.query(TyperUser).filter(TyperUser.id == typer_user_id).first()
