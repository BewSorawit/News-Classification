from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from utils.auth import get_current_user
from database import get_db
from schemas.users import UserCreate, UserResponse, UserUpdate
from crud.users import create_user, get_all_users, delete_user, update_user
from crud.typer_user import get_typer_user_by_id
from models.typer_user import RoleEnum
router = APIRouter()


# admin
@router.post("/users", response_model=UserResponse)
def create_new_user(
    user: UserCreate,
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):

    typer_user = get_typer_user_by_id(db, current_user.get("typer_user_id"))
    # print(typer_user.__dict__)

    if not typer_user or typer_user.role != RoleEnum.admin:
        raise HTTPException(
            status_code=status.HTTP_403_FORBIDDEN,
            detail="You do not have permission to create a new user.",
        )

    return create_user(db=db, user=user)


@router.get("/users", response_model=list[UserResponse])
def read_all_users(
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):
    typer_user = get_typer_user_by_id(db, current_user.get("typer_user_id"))
    # print(typer_user.__dict__)

    if not typer_user or typer_user.role != RoleEnum.admin:
        raise HTTPException(
            status_code=status.HTTP_403_FORBIDDEN,
            detail="You do not have permission to create a new user.",
        )

    users = get_all_users(db)
    return users


@router.put('/users/{user_id}', response_model=UserResponse)
def update_user_endpoint(
    user_id: int,
    user_data: UserUpdate,
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):
    typer_user = get_typer_user_by_id(db, current_user.get("typer_user_id"))
    # print(typer_user.__dict__)

    if not typer_user or typer_user.role != RoleEnum.admin:
        raise HTTPException(
            status_code=status.HTTP_403_FORBIDDEN,
            detail="You do not have permission to create a new user.",
        )

    updated_user = update_user(user_id, user_data, db)
    return updated_user


@router.delete("/users/{user_id}", status_code=status.HTTP_204_NO_CONTENT)
def remove_user(
    user_id: int,
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):
    typer_user = get_typer_user_by_id(db, current_user.get("typer_user_id"))
    # print(typer_user.__dict__)

    if not typer_user or typer_user.role != RoleEnum.admin:
        raise HTTPException(
            status_code=status.HTTP_403_FORBIDDEN,
            detail="You do not have permission to create a new user.",
        )

    delete_user(user_id, db)
    return {"message": "User deleted successfully"}
